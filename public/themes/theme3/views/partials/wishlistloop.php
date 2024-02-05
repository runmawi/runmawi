<?php if(isset($wishlist_movies)) :
foreach($wishlist_movies as $wishlist_movie): ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('play_movie') : URL::to('play_movie') ?><?= '/' . $wishlist_movie->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($wishlist_movie->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $wishlist_movie->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $wishlist_movie->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($wishlist_movie->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $wishlist_movie->genre->name;?></p></div>
            </div>
            <img src="<?= ImageHandler::getImage($wishlist_movie->image, 'medium')  ?>">
        </a>
        <div class="block-contents">
            <p class="movie-title padding"><?php echo $wishlist_movie->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
else: ?>
            <h3 class="vid-title">No Videos/Movies Added to Wishlist.</h3>
            <div>
                <a class="btn btn-play">Add Now</a>
                <a class="btn btn-play">Go Home</a>
            </div>
<?php endif; ?>

<?php if(isset($wishlist_videos)) :
foreach($wishlist_videos as $wishlist_video): ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('play_movie') : URL::to('play_movie') ?><?= '/' . $wishlist_video->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($wishlist_video->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $wishlist_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $wishlist_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($wishlist_video->duration); ?></span>
                </p>
                </div>

            </div>
            <img src="<?= ImageHandler::getImage($wishlist_video->image, 'medium')  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $wishlist_video->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach; 
endif; ?>






<div class="clear"></div>

        <?php  if(isset($wishlist_audeos)) : ?>
            <h3 class="vid-title"> Wishlist Audios. </h3>
		<?php	foreach($wishlist_audeos as $audio): 
        
        $slugID = DB::table('audio_albums')->where('id', $audio->album_id)->pluck('slug');
        $albumname = DB::table('audio_albums')->where('id', $audio->album_id)->pluck('albumname');
        //echo $audioID;
        ?>
            <?php if(!Auth::guest()):
                    if($audio->url == 'audio'):
                    $id='audio_id';
                    elseif($audio->url == 'play_movie'):
                    $id='movie_id';
                    elseif($audio->url == 'episodes'):
                    $id='episode_id';
                    endif;
                   
                  endif;
            ?>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 new-art">
            <article class="block expand">
                <a class="block-thumbnail"  href="<?php echo URL::to('/').'/audio/'.$slugID.'/'.$audio->slug;?>">
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
                        <div class="thriller"> <p><?= $albumname;?></p></div>
                    </div>
                    <img src="<?= ImageHandler::getImage($audio->image, 'medium')  ?>">
                </a>
             

                 <div class="block-contents">
                    <p class="movie-title padding"><?= $audio->title; ?></p>
                </div>
            </article>
        </div>
			<?php endforeach; 
		endif; ?>

    <div style="height: 10px;"></div>



<?php if(isset($watchlater_videos)) :
foreach($watchlater_videos as $watchlater_video): ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('play_movie') : URL::to('play_movie') ?><?= '/' . $watchlater_video->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($watchlater_video->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($watchlater_video->duration); ?></span>
                </p>
                </div>
            </div>
            <img src="<?= ImageHandler::getImage($watchlater_video->image, 'medium')  ?>">
        </a>
        <div class="block-contents">
            <p class="movie-title padding"><?php echo $watchlater_video->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach; 
endif; ?>
<div class="clear"></div>
<?php 
 if(count($watchlater_movies) > 0) : ?>
  <h3 class="vid-title"> Purchased Movies. </h3>

<?php 

 foreach($watchlater_movies as $watchlater_movie):

  $movie_id = $watchlater_movie->id;

  $user_id = Auth::user()->id;

  $daten = date('Y-m-d h:i:s a', time());

  $movie_details = DB::table('ppv_purchase')->where('user_id',$user_id)->where('movie_id',$movie_id)->first();
  $movie_time = $movie_details->to_time;
echo $movie_time;
?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('mywatchlater') : URL::to('play_movie') ?><?= '/' . $watchlater_movie->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($watchlater_movie->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_movie->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_movie->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($watchlater_movie->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $watchlater_movie->genre->name;?></p></div>
            </div>
            <img src="<?= ImageHandler::getImage($watchlater_movie->image, 'medium')  ?>">
        </a>
        
        <div class="block-contents">
            <p class="movie-title padding"><?php echo $watchlater_movie->title; ?></p>
            <?php if ($daten > $movie_time ) { ?>
    
                <div class="thriller"> <p>Expired</p></div>
          <?php } ?>
            
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>

<div class="clear"></div>
<div class="video-list">
   
    <div class="border-line" style="margin-bottom:15px;"></div>
	<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        <?php 
        if(count($watchlater_audeos) > 0) :?>
         <h3 class="vid-title"> Purchased Audios. </h3>
		<?php
			foreach($watchlater_audeos as $audio): 
        
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
	</div>
    <div style="height: 10px;"></div>
   
</div>





<div class="clear"></div>
<?php if(isset($watchlater_episodes)) :
foreach($watchlater_episodes as $watchlater_episode): ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('mywatchlater') : URL::to('watchlater_episode') ?><?= '/' . $watchlater_episode->id ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($watchlater_episode->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_episode->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_episode->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($watchlater_episode->duration); ?></span>
                </p>
                </div>
            </div>
            <img src="<?= ImageHandler::getImage($watchlater_episode->image, 'medium')  ?>">
        </a>
        <div class="block-contents">
            <p class="movie-title padding"><?php echo $watchlater_episode->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>
<?php if(count($watchlater_movies) == 0 && count($watchlater_audeos) == 0){
    echo "<h3>No Data Found</h3>";
}?>
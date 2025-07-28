<?php foreach($related as $movie): ?>
<?php if(!Auth::guest()):
  if($movie->url == 'video'):
    $id='video_id';
  elseif($movie->url == 'play_movie'):
    $id='movie_id';
  elseif($movie->url == 'episodes'):
    $id='episode_id';
  endif;
  $like = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $movie->id)->where('status', '=', 1)->first();
  $dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $movie->id)->where('status', '=', 0)->first();
endif;
?>
<div class="new-art">
    <article class="block expand">
        <a class="block-thumbnail" href="<?php echo URL::to('/').'/play_movie/'.$movie->slug;?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($movie->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $movie->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $movie->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($movie->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $movie->genre->name;?></p></div>
            </div>
            <img src="<?= ImageHandler::getImage($movie->image, 'medium')  ?>">
        </a>
        <div class="block-contents">
            <p class="movie-title padding"><?php echo $movie->title; ?></p>
        </div>
    </article>
</div>
<?php endforeach; ?>

<?php foreach($movies as $movie): ?>
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
                    <span class="running-time"><i class="fa fa-clock-o"></i></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $movie->title;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$movie->player_image;  ?>">
        </a>

        <!-- <div class="flex-icons">
                <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
                <a class="like <?php if(isset($like->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $movie->id ?>" data-url="<?= $movie->url; ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
                <a class="dislike <?php if(isset($dislike->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $movie->id ?>" data-url="<?= $movie->url; ?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
            </div> --> 
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $movie->title; ?></p>
        </div>
    </article>
</div>
<?php endforeach; ?>

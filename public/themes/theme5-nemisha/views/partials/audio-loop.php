<div class="video-list">
    <h4 class="Continue Watching text-left padding-top-40 padding-bottom-20">Latest Audios</h4>
    <div class="border-line" style="margin-bottom:15px;"></div>
	<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        <?php  if(isset($latest_audios)) :
			foreach($latest_audios as $audio): 
        
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
                    $like = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $audio->id)->where('status', '=', 1)->first();
                    $dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $audio->id)->where('status', '=', 0)->first();
                  endif;
            ?>
        <div class="new-art">
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
                            <span class="running-time"><i class="fa fa-clock-o"></i></span>
                        </p>
                        </div>
                        <div class="thriller"> <p><?= $albumname;?></p></div>
                    </div>
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;  ?>">
                </a>
               <!-- <div class="flex-icons">
                    <a href="<?= $audio->url;?>/<?= $audio->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                    <!--<a href="<?= $audio->url;?>/<?= $audio->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
<a class="like <?php if(isset($like->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $audio->id ?>" data-url="<?= $audio->url; ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
<a class="dislike <?php if(isset($dislike->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $audio->id ?>" data-url="<?= $audio->url; ?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                </div> -->

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
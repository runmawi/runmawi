<div class="video-list">
    <h4 class="Continue Watching text-left padding-top-40 padding-bottom-20">Latest Audios</h4>
    <div class="border-line" style="margin-bottom:15px;"></div>
	<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        <?php  if(isset($latest_audios)) :
			foreach($latest_audios as $audio): ?>
        <div class="new-art" data-id="v-<?= $audio->id; ?>">
            <article class="block expand">
                <a class="block-thumbnail"  href="#v-<?= $audio->id; ?>" data-toggle="tab">
                <div class="thumbnail-overlay"></div>
                    <img src="<?= ImageHandler::getImage($audio->image, 'medium')  ?>">
                </a>
                <div class="block-overlap block-class_v-<?= $audio->id ?>" style="display: none;">
                    <div style="display:flex;align-items: center;">
                        <div>
                            <a class="flexlink" href="<?php echo URL::to('/').'/audio/'.$audio->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                        <div style="width: 90%;">
                            <h4><?= ucfirst($audio->title); ?></h4>
                            <p style="margin-bottom: 30px;">
                                IMDb <?= $audio->rating;?> 
                                <span>(<?= $audio->views;?>)</span>
                                <span style="margin-left:5%;">1h 50m</span>
                                <span style="margin-left:5%;">2018</span>
                            </p>
                            <div class="thriller">
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
                                <div class="flex-icons">
                                    <a href="<?= $audio->url;?>/<?= $audio->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                                    <a href="<?= $audio->url;?>/<?= $audio->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
<a class="like <?php if(isset($like->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $audio->id ?>" data-url="<?= $audio->url; ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
<a class="dislike <?php if(isset($dislike->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $audio->id ?>" data-url="<?= $audio->url; ?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <p class="text-left" style="background-color: #1a1b20; color: #fff;padding-top: 10px;"><?php echo $audio->title;?></p>
            </article>
        </div>
			<?php endforeach; 
		endif; ?>
	</div>
    <div style="height: 10px;"></div>
   
</div>
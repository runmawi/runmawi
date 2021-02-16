<?php  if(isset($featured_movies)) :?>
<div class="video-list">
    <p class="Continue Watching section-head">Popular Films</p>
    <div class="border-line" style="margin-bottom:15px;"></div>
	<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        
          <?php  foreach($featured_movies as $video): ?>
        <div class="new-art" data-id="fm-<?= $video->id; ?>">
            <article class="block expand">
                <a class="block-thumbnail"  href="#fm-<?= $video->id; ?>" data-toggle="tab">
                <div class="thumbnail-overlay"></div>
                    <img src="<?= ImageHandler::getImage($video->image, 'medium')  ?>">
                </a>
                <div class="block-overlap block-class_fm-<?= $video->id ?>" style="display: none;">
                    <div style="display:flex;align-items: center;">
                        <div>
                            <a class="flexlink" href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                        <div style="width: 90%;">
                            <h4><?= ucfirst($video->title); ?></h4>
                            <p style="margin-bottom: 30px;">
                                IMDb <?= $video->rating;?> 
                                <span>(<?= $video->views;?>)</span>
                                <span style="margin-left:5%;">1h 50m</span>
                                <span style="margin-left:5%;">2018</span>
                            </p>
                            <div class="thriller">
                                <?php if(!Auth::guest()):
                          if($video->url == 'video'):
                            $id='video_id';
                          elseif($video->url == 'play_movie'):
                            $id='movie_id';
                          elseif($video->url == 'episodes'):
                            $id='episode_id';
                          endif;
                          $like = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $video->id)->where('status', '=', 1)->first();
                          $dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $video->id)->where('status', '=', 0)->first();
                        endif;
                        ?>
                                <div class="flex-icons">
                                    <a href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                                    <a href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
                                    <a class="like <?php if(isset($like->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" data-url="<?= $video->url; ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
                            <a class="dislike <?php if(isset($dislike->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" data-url="<?= $video->url; ?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
            <?php endforeach; ?>
    </div>
    <div style="height: 10px;"></div>
    <div class="tab-content">
        <?php foreach($featured_movies as $movie): ?>
        <div class="tab-pane row" id="fm-<?= $movie->id; ?>" style="position: relative;">
            <div class="thumbnailbg" style="background-image:url(<?= ImageHandler::getImage($movie->image, '')  ?>);">
                <div class="imagetopdetails">
                <p class="joker-titl padding-top-5"><?= ucfirst($movie->title);?></p>
                <div class="movie-type">
                    <?php if($movie->rating > 0){ ?>
                    <div class="star-valid">
                        <i class="fa fa-star"></i>
                    </div>
                    <?php }else{ ?>
                    <i class="fa fa-star fa-2x"></i>
                    <?php } ?>
                    <p class="ratingg"><?= $movie->rating;?> <span>(<?= $movie->views;?>)</span></p>
                </div>
                <div class="video-buttons">
                    <div class="video-button-1 video-play">
                        <a href="<?= $movie->url;?>/<?= $movie->id;?>"><i class="fa fa-play" aria-hidden="true"></i> Play</a>
                    </div>
                    <?php if(!Auth::guest()):
                        if($movie->url == 'video'):
                            $id='video_id';
                        elseif($movie->url == 'play_movie'):
                            $id='movie_id';
                        elseif($movie->url == 'episodes'):
                            $id='episode_id';
                        endif;
                        $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where($id, '=', $movie->id)->first();
                    endif;
                    ?>
                    <div class="add-wishlist video-button-1 mywishlist <?php if(isset($wishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $movie->id ?>" data-url="<?= $movie->url; ?>">
                        <a>
                            <i class="<?php if(isset($wishlisted->id)): ?>fa fa-check<?php else: ?> fa fa-plus <?php endif; ?>"></i> <?php if(isset($wishlisted->id)): ?>Wishlisted<?php else: ?> Add Wishlist <?php endif; ?>
                        </a>
                    </div>

                    <div class="more-info video-button-1">
                        <a href="/saka/info"><i class="fa fa-info"></i> More info</a>
                    </div>
                </div>
                <div style="clear: both"></div>
                <div class="joker-descrip">
                    <p class="padding-top-20"><?= $movie->description;?></p>
                </div> 
            </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php  endif; ?>
<!-- Popular videos -->
<?php  if(isset($featured_videos)) :?>
<div class="video-list">
    <p class="Continue Watching section-head">Popular Videos</p>
    <div class="border-line" style="margin-bottom:15px;"></div>
    <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        
          <?php  foreach($featured_videos as $video): ?>
        <div class="new-art" data-id="fv-<?= $video->id; ?>">
            <article class="block">
                <a class="block-thumbnail"  href="#fv-<?= $video->id; ?>" data-toggle="tab">
                <div class="thumbnail-overlay"></div>
                    <img src="<?= ImageHandler::getImage($video->image, 'medium')  ?>">
                </a>
                <div class="block-overlap block-class_fv-<?= $video->id ?>" style="display: none;">
                    <div style="display:flex;align-items: center;">
                        <div>
                            <a class="flexlink" href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                        <div style="width: 90%;">
                            <h4><?= ucfirst($video->title); ?></h4>
                            <p style="margin-bottom: 30px;">
                                IMDb <?= $video->rating;?> 
                                <span>(<?= $video->views;?>)</span>
                                <span style="margin-left:5%;">1h 50m</span>
                                <span style="margin-left:5%;">2018</span>
                            </p>
                            <div class="thriller">
                                 <?php if(!Auth::guest()):
                            if($video->url == 'video'):
                            $id='video_id';
                            elseif($video->url == 'play_movie'):
                            $id='movie_id';
                            elseif($video->url == 'episodes'):
                            $id='episode_id';
                            endif;
                            $like = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $video->id)->where('status', '=', 1)->first();
                            $dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where($id, '=', $video->id)->where('status', '=', 0)->first();
                            endif;
                            ?>
                                <div class="flex-icons">
                                    <a href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                                    <a href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
<a class="like <?php if(isset($like->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" data-url="<?= $video->url; ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
<a class="dislike <?php if(isset($dislike->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" data-url="<?= $video->url; ?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
            <?php endforeach; ?>
    </div>
    <div style="height: 10px;"></div>
    <div class="tab-content">
        <?php foreach($featured_videos as $video): ?>
        <div class="tab-pane row" id="fv-<?= $video->id; ?>" style="position: relative;">
            <div class="thumbnailbg" style="background-image:url(<?= ImageHandler::getImage($video->image, '')  ?>);">
            <div class="imagetopdetails">
                <p class="joker-titl padding-top-5"><?= ucfirst($video->title);?></p>
                <div class="movie-type">
                    <?php if($video->rating > 0){ ?>
                    <div class="star-valid">
                        <i class="fa fa-star"></i>
                    </div>
                    <?php }else{ ?>
                    <i class="fa fa-star fa-2x"></i>
                    <?php } ?>
                    <p class="ratingg"><?= $video->rating;?> <span>(<?= $video->views;?>)</span></p>
                </div>
                <div class="video-buttons">
                    <div class="video-button-1 video-play">
                        <a href="<?= $video->url;?>/<?= $video->id;?>"><i class="fa fa-play" aria-hidden="true"></i> Play</a>
                    </div>
                    <?php if(!Auth::guest()):
                        if($video->url == 'video'):
                            $id='video_id';
                        elseif($video->url == 'play_movie'):
                            $id='movie_id';
                        elseif($video->url == 'episodes'):
                            $id='episode_id';
                        endif;
                        $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where($id, '=', $video->id)->first();
                    endif;
                    ?>
                    <div class="add-wishlist video-button-1 mywishlist <?php if(isset($wishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>" data-url="<?= $video->url; ?>">
                        <a>
                            <i class="<?php if(isset($wishlisted->id)): ?>fa fa-check<?php else: ?> fa fa-plus <?php endif; ?>"></i> <?php if(isset($wishlisted->id)): ?>Wishlisted<?php else: ?> Add Wishlist <?php endif; ?>
                        </a>
                    </div>

                    <div class="more-info video-button-1">
                        <a href="/saka/info"><i class="fa fa-info"></i> More info</a>
                    </div>
                </div>
                <div style="clear: both"></div>
                <div class="joker-descrip">
                    <p class="padding-top-20"><?= $video->description;?></p>
                </div> 
            </div> 
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php  endif; ?>
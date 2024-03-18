
<h2>Latest Videos</h2>
    <div class="border-line" style="margin-bottom:15px;"></div>
	<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
        <?php  if(isset($latest_videos)) :
			foreach($latest_videos as $watchlater_video): ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 new-art">
                    <article class="block expand">
                        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->id ?>">
                            <div class="play-button">
                                <div class="play-block">
                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                                </div>
                                <div class="detail-block">
                                <p class="movie-title"><?= ucfirst($watchlater_video->title); ?></p>
                                <p class="movie-rating">
                                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                    <span class="running-time"><i class="fa fa-clock-o"></i><?=$watchlater_video->duration; ?></span>
                                </p>
                                </div>
                            </div>
                            
                            <?php if (!empty($watchlater_video->trailer)) { ?>

                                <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
                                </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>">
                            <?php } ?>
                            
                        </a>
                        
                        <div class="block-contents">
                            <p class="movie-title padding"><?php echo $watchlater_video->title; ?></p>
                        </div>
                    </article>
                </div>
			<?php endforeach; 
		endif; ?>
	</div>
    <div style="height: 10px;"></div>


 <script> 
        
        $(document).ready(function() { 
            $(".play-video").hover(function() { 
                $(this).css("display", "block"); 
            }, function() { 
             //$(this).css("display", "none"); 
                 $(".play-video").load(); 
            }); 
            
          $( ".play-video" ).mouseleave(function() {
            $(this).load(); 
        });
            
            
            
        }); 
    </script> 
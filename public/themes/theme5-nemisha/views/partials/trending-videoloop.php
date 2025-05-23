<div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 overflow-hidden">
         <div class="iq-main-header d-flex align-items-center justify-content-between">                        
            <h4 class="main-title"><a href="href="<?php echo URL::to('home') ?>"">Upcoming Videos</a></h4>
         </div>
         <div class="upcoming-contens">
            <ul class="favorites-slider list-inline row p-0 mb-0">
               <?php if(isset($featured_videos)) :
                     foreach($featured_videos as $watchlater_video): ?>
               <li class="slide-item">
                  <a href="<?php echo URL::to('home') ?>">
                     <div class="block-images position-relative">
                        <div class="img-box">
                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>" class="img-fluid" alt="">
                        </div>
                        <div class="block-description">
                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                           <h6><?php echo __($watchlater_video->title); ?></h6>
                            </a>
                           <div class="movie-time d-flex align-items-center my-2">
                              <div class="badge badge-secondary p-1 mr-2">5+</div>
                              <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                           </div>
                           <div class="hover-buttons">
                               <button type="button" class="btn btn-primary btn-hover" data-toggle="modal" data-target=".bd-example-modal-xl2<?= $watchlater_video->id;?>">
                              <span class="btn ">
                              <i class="fa fa-play mr-1" aria-hidden="true"></i>
                              Play Now
                              </span>
                               </button>
                           </div>
                              <div>
                                <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                        <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="block-social-info">
                           <ul class="list-inline p-0 m-0 music-play-lists">
                              <li><span><i class="ri-volume-mute-fill"></i></span></li>
                              <li><span><i class="ri-heart-fill"></i></span></li>
                              <li><span><i class="ri-add-line"></i></span></li>
                           </ul>
                        </div>
                     </div>
                  </a>
               </li>
               <?php endforeach; 
                      endif; ?>
            </ul>
         </div>
      </div>
    </div>
</div>
<?php if(isset($featured_videos)) :
        foreach($featured_videos as $watchlater_video): ?>
        <div class="modal fade bd-example-modal-xl2<?= $watchlater_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background-color: transparent !important;">
               <div class="modal-body playvid">
                     <?php if($watchlater_video->type == 'embed'): ?>
                                <div id="video_container" class="fitvid">
                                    <?= $watchlater_video->embed_code ?>
                                </div>
                            <?php  elseif($watchlater_video->type == 'file'): ?>
                                <div id="video_container" class="fitvid">
                                <video id="videojs-seek-buttons-player"   onplay="playstart()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/') . '/uploads/images/' . $watchlater_video->player_image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                    <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >
                                    <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->webm_url; ?>" type='video/webm' label='auto' >
                                    <source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                </video>
                                <div class="playertextbox hide">
                                <h2>Up Next</h2>
                                <p><?php if(isset($videonext)){ ?>
                                <?= $watchlater_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                <?php }elseif(isset($videoprev)){ ?>
                                <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                <?php } ?>

                                <?php if(isset($videos_category_next)){ ?>
                                <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                <?php }elseif(isset($videos_category_prev)){ ?>
                                <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                <?php } ?></p>
                                </div>
                                </div>
                            <?php  else: ?>
                                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                <video id="videojs-seek-buttons-player" onplay="playstart()"  class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->player_image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >

                                </video>


                                <div class="playertextbox hide">
                                <h2>Up Next</h2>
                                <p><?php if(isset($videonext)){ ?>
                                <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                <?php }elseif(isset($videoprev)){ ?>
                                <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                <?php } ?>

                                <?php if(isset($videos_category_next)){ ?>
                                <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                <?php }elseif(isset($videos_category_prev)){ ?>
                                <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                <?php } ?></p>
                                </div>
                                </div>
                     <?php endif; ?></div>
                        <div class="modal-footer" align="center" >
                            <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
            onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>

                         </div>
                    </div>
                </div>
            </div>
<?php endforeach; 
		                                   endif; ?>
<?php if(isset($featured_videos)) :
                                foreach($featured_videos as $watchlater_video): ?>
                                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="lv_vid<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $watchlater_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($watchlater_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $watchlater_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                           	
                                                       <!-- <div class="btn btn-danger btn-right-space br-0">
                                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                                </div>-->
                                         <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

		
				<?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>"  muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
<!--			<a  href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>-->
                <div class="detail-block">
<!--					<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
					</a>-->
					
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
					</p>-->

				</div>
		</div>
		</a>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
        </div>
	</div> 
	            
    </div>
    <div id="like<?= $watchlater_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $watchlater_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
	</div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $watchlater_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $watchlater_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $watchlater_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $watchlater_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>


	
	</div></div>

<?php endforeach; 
      endif; ?>
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
<script>
    $(document).ready(function () {
      $(".thumb-cont").hide();
      $(".show-details-button").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).show();
      });
		$(".closewin").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).hide();
      });
    });
  </scr ipt>
<script>
function about(evt , id) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    
  }
	
  document.getElementById(id).style.display = "block";
 
}
</script>
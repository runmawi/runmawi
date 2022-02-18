<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Reels</h4>                                          
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($Reels_videos)) :
                foreach($Reels_videos as $reel): 
            ?>
            <li class="slide-item">
                    <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="<?php echo URL::to('Reals_videos') ?><?= '/videos/' . $reel->slug ?>">
                                    <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$reel->image;  ?>"  data-play="hover" >
                                        <source src="<?php echo $reel->trailer;  ?>" type="video/mp4">
                                    </video>
                                </a>
                            </div>
                                
                            <div class="block-description" >
                                <a  class="text-white"  data-toggle="modal" data-target="#Reels">
                                     <h6><?php echo __($reel->title); ?></h6></a>
                                
                               <div class="hover-buttons">
                                   <a class="text-white"  data-toggle="modal" data-target="#Reels"  >
                                         <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now </a>
                               </div>
                        </div>
                    </div>
                </a>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>




<!-- Reels Modal -->

<div class="modal fade" id="Reels" tabindex="-1" role="dialog" aria-labelledby="Reels" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
            <div class="modal-body">
                <video id="ReelsVideos" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>"
                    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
                    <source src="<?php echo URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;?>" type="video/mp4" label='720p' res='720'/> 
                </video>
            </div>
      </div>
    </div>
</div>



<script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>

<script>


// for Reels videos
const player = new Plyr('#ReelsVideos',{
          controls: [

      'play-large',
			'restart',
			'rewind',
			'play',
			'fast-forward',
			'progress',
			'current-time',
			'mute',
			'volume',
			'captions',
			'settings',
			'pip',
			'airplay',
			'fullscreen',
			'capture'
		],
});
    </script>
 
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Reels</h4>                      
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($Reels_videos)) :
                foreach($Reels_videos as $key => $reel): 
            ?>

            <li class="slide-item">
                <a href="<?php echo URL::to('home') ?>">
                    <div class="block-images position-relative Reels_video_ir" data-toggle="modal" data-target="#Reels" id="">
                            <div class="img-box">
                                <a>
                                    <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$reel->reels_thumbnail;  ?>"  data-play="hover" >
                                        <source src="<?php echo $reel->trailer;  ?>" type="video/mp4">
                                    </video>
                                </a>
                            </div>
                    </div>
                    
                    <div class="block-description">
                            <div class="hover-buttons">
                                <a class="text-white btn-cl"  data-toggle="modal" data-target="#Reels">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png'; ?>" data-name=<?php echo $reel->reels_videos ?> onclick="addvidoes(this)" ></a>
                            </div>
                    </div>

                    <div class="mt-2">
                            <h6><?php  echo (strlen($reel->reels_videos_slug) > 25) ? substr($reel->reels_videos_slug,0,26).'...' : $reel->reels_videos_slug; ?></h6>
                            <div class="movie-time d-flex align-items-center my-2">
                                 <input type="hidden" name="reals_videos_id" class="reals_videos_id" value=<?php echo $reel->reels_videos ?> >
                            </div>
                    </div>
                </a>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>


 <!-- Reels Modal -->

 <div class="modal fade" id="Reels" tabindex="-1" role="dialog" aria-labelledby="Reels" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
            <div class="modal-body" id="Reels_player"  >
                <video>
                    <source src="<?php echo URL::to('public/uploads/reelsVideos').'/'.$reel->reelvideo;?>" type="video/mp4" label='720p' res='720'/> 
                </video>
            </div>

            <div class="modal-footer" style="">
                <button type="button" class="btn btn-secondary reelsclose" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
   
</div>
</div>


<!-- Reels Player -->

<?php $ReelVideos = URL::to('public/uploads/reelsVideos').'/';  ?>
<script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>

<script>

    function addvidoes(ele) 
        {
            var Reels_videos = $(ele).attr('data-name');
            var Reels_url = <?php echo json_encode($ReelVideos); ?>;
            var Reels = Reels_url+Reels_videos;
            var player = new Playerjs({id:"Reels_player", file:Reels,autoplay:1});
        }

    $(document).ready(function(){
        $(".reelsclose").click(function(){
            var player = new Playerjs({id:"Reels_player", file:Reels,stop:1});
        });
    });
</script>

<style>
    .modal-body{
        position: unset;
    }
    .modal-footer{
        background: black;
    }
</style>
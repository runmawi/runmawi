<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Reels</h4>                      
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($Reels_videos)) :
                foreach($Reels_videos as $reel): 
            ?>

            <li class="slide-item">
                <a href="<?php echo URL::to('home') ?>">
                    <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="#">
                                    <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$reel->image;  ?>"  data-play="hover" >
                                        <source src="<?php echo $reel->trailer;  ?>" type="video/mp4">
                                    </video>
                                </a>
                            </div>
                    </div>
                    
                    <div class="block-description">
                            <div class="hover-buttons">
                                <a class="text-white btn-cl"  data-toggle="modal" data-target="#Reels">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png';  ?>"></a>
                            </div>
                    </div>

                    <div class="mt-2">
                              <!-- <a  href="<?php //echo URL::to('Reals_videos') ?><?// '/videos/' . $reel->slug ?>">
                                      </a> -->
                                      <h6><?php echo __($reel->title); ?></h6>
                                <div class="movie-time d-flex align-items-center my-2">
                                    <div class="badge badge-secondary p-1 mr-2"><?php echo $reel->age_restrict ?></div>
                                </div>
                    </div>
                </a>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>


 <!-- Reels Modal -->

<div class="modal fade" id="Reels" tabindex="-1" role="dialog" aria-labelledby="Reels" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
            <div class="modal-body" id="Reels_player"  >
                <video>
                    <source src="<?php echo URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;?>" type="video/mp4" label='720p' res='720'/> 
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

<?php $ReelVideos = URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;  ?>
<script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>

<script>
    var Reels = <?php echo json_encode($ReelVideos); ?>;
    var player = new Playerjs({id:"Reels_player", file:Reels,autoplay:1});

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
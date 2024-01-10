
@php
    include(public_path('themes/theme3/views/header.php'));
@endphp
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">{{ __('Reels') }}</h4>                                          
</div>
<div class="favorites-contens">
    
    <!-- Reels Modal -->
    <?php  foreach($Reels_videos as $video): ?>
                <div  id="Reels_player"  data-name=<?php echo $video->reels_videos ?>  onclick="addvidoes(this)"  style="margin-left: 25%;width: 50%">
                    <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->reels_thumbnail;  ?>"  data-play="hover">
                        <source  src="<?php //echo URL::to('public/uploads/reelsVideos').'/'.$video->reels_videos;?>" type="video/mp4" label='720p' res='720'/> 
                    </video> -->
                    <video   id="videoPlayer" class=""
                        poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" 
                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' 
                    src="<?php echo  URL::to('public/uploads/reelsVideos').'/'.$video->reels_videos; ?>"  type="video/mp4" >
                </div>
                <br>
                <input type="hidden" id="reelsvideos" value="<?php echo $video->reels_videos ?>">
            </div>
    <?php endforeach; ?>

<!-- Reels Player -->

<?php $ReelVideos = URL::to('public/uploads/reelsVideos').'/';  ?>
<script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
      function addvidoes(ele) 
        {
            // var Reels_videos = $(ele).attr('data-name');
            // var Reels_url = <?php echo json_encode($ReelVideos); ?>;
            // var Reels = Reels_url+Reels_videos;
            // var player = new Playerjs({id:"Reels_player", file:Reels,autoplay:1});
            // alert(Reels_videos);
        }

            $(document).ready(function(){

            //   const player = new Plyr('#videoPlayer');
              var players_multiple = Plyr.setup('#videoPlayer');
});

// var player = new Playerjs({id:"Reels_player",autoplay:1});

    // $(document).ready(function(){
    //     $(".reelsclose").click(function(){
    //         var player = new Playerjs({id:"Reels_player", file:Reels,stop:1});
    //     });
    // });
</script>


@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section id="">
            <div class="">
               <div class="row">
                  <div class="col-sm-12 ">
                     <div class="iq-main-header align-items-center justify-content-between">
                        <!--<h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->                     
                     </div>
                     <div class=" boder">
                        <ul class=" list-inline row mb-0">
                            <?php if(isset($all_play_list_videos)) :
                           foreach($all_play_list_videos as $watchlater_video): ?>
                           <li class="">
                              <a href="#" data-video-id=<?php echo $watchlater_video->id; ?> onclick="Video_Playlist(this)">
                                 <div class="position-relative row playlist" >
                                    <div class=" col-sm-6 p-0">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>" class="img-fluid w-100" alt="recom">
                                     </div>
                                     <div class="col-sm-6">
                                       <h6><?php  echo (strlen($watchlater_video->title) > 15) ? substr($watchlater_video->title,0,15).'...' : $watchlater_video->title; ?></h6>
                                       <div class="movie-time  align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict.' '.'+' ?></div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       

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

</section>

<script>
    
    function Video_Playlist(ele) {

var video_id = $(ele).attr('data-video-id');

$.ajax({
    type: "get",
    url: "<?= route('video_playlist_play') ?>",
    data: {
        _token: "<?= csrf_token() ?>",
        video_id: video_id,
    },
    success: function(data) {
        $(".video_playlist_content").html(data);
    },
});
}
</script>

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
<!--<script>
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
  </script>-->
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
// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>




   
<!--<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

   <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>-->
   <!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->
  <!--  <script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
 <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
 <script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>
<!--<script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
<script>
var vid = document.getElementById("videojs-seek-buttons-player");
vid.onloadeddata = function() {

    // get the current players AudioTrackList object
    var player = videojs('videojs-seek-buttons-player')
    let tracks = player.audioTracks();

    alert(tracks.length);

    for (let i = 0; i < tracks.length; i++) {
        let track = tracks[i];
        console.log(track);
        alert(track.language);
    }
};
</script>-->



       <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />

<?php 
$series= App\series::first();
 ?>
<?php
$series= App\series::where('id',$episode->series_id)->first();
$SeriesSeason= App\SeriesSeason::where('id',$episode->season_id)->first();
// dd($SeriesSeason);
?>
<input type="hidden" value="<?php echo URL::to('/');?>" id="base_url" >
<input type="hidden" id="videoslug" value="<?php if(isset($episode->path)) { echo $episode->path; } else{ echo "0";}?>">
<input type="hidden" value="<?php echo $episode->type; ?>" id='episode_type'>

	<div id="series_bg">
		<div class="">
			
			<?php 


			if($episode->access == 'guest' || $episode->access == 'subscriber' || $episode->access == 'registered'): 
			?>
				
					<?php if($episode->type == 'embed'): ?>
						<div id="series_container" class="fitvid">
							<?= $episode->embed_code ?>
						</div>
					<?php  elseif($episode->type == 'file' || $episode->type == 'upload'): ?>
						<div id="series_container">

						 <video id="videoPlayer"  class="video-js vjs-default-skin" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' width="100%" style="width:100%;" type="video/mp4"  data-authenticated="<?= !Auth::guest() ?>">
							<source src="<?= $episode->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?= $episode->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?= $episode->ogg_url; ?>" type='video/ogg' label='auto' >
							<?php  if(isset($episodesubtitles)){
							foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
							<track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
							<?php } } ?>
							<p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 series</a></p>
						</video>
						</div>
						<?php  elseif($episode->type == 'm3u8'): ?>
							<div id="series_container">
								 <video id="video"  controls crossorigin playsinline 
								 poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" 
								 controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
									<source 
										type="application/x-mpegURL" 
										src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '.m3u8'; ?>"
									>
									</video>
								<?php  if(isset($episodesubtitles)){
								foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
								<track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
								<?php } } ?>
								</video>
								</div>
					<?php  else: ?>                                  
						<div id="series_container">
						<video id="videoPlayer"    class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
                           
							<source src="<?php echo URL::to('/storage/app/public/').'/'.'TfLwBgA62jiyfpce_2_1000_00018'; ?>" type='application/x-mpegURL' label='360p' res='360' />
								<source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
									<source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 
						
						</video>
						</div>
					<?php endif; ?>
					 <div class="logo_player"> </div>

	<!-- Intro Skip and Recap Skip -->
		
			<div class="col-sm-12 intro_skips">
				<input type="button" class="skips" value="Skip Intro" id="intro_skip">
				<input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
			</div>	

			<div class="col-sm-12 Recap_skip">
     			 <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip" style="display:none;">
  			</div>

  	<!-- Intro Skip and Recap Skip -->

			<?php else: ?>

                <div id="subscribers_only"style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)), url(<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 100vh; margin-top: 20px;display: flex;    justify-content: center;    flex-direction: column;    align-items: center;">
					<h2>Sorry, this series is only available to <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
					<div class="clear"></div>
					<?php if(!Auth::guest() && $series->access == 'subscriber'): ?>
						<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
							<button id="button">Become a subscriber to watch this episode</button>
						</form>
					<?php else: ?>
						<form method="get" action="<?= URL::to('signup') ?>" class="mt-4">
							<button id="button" class="btn bd">Signup Now <?php if($series->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($series->access == 'registered'): ?>for Free!<?php endif; ?></button>
						</form>
					<?php endif; ?>
				</div>
			
			<?php endif; 
			 
			?>
		</div>
	</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>" value="<?= $episode->genre_id ?>">
<br>


		<div class="clear"></div>

		<input type="hidden" id="episode_id" value="<?php echo $episode->id ; ?>">
    
	
    </script>
  

<style>
     p{
        color: #fff;
    }
	.free_content{	
    margin: 100px;
    border: 1px solid red;
    padding: 5% !important;
	border-radius: 5px;
	}
		p.Subscribe {
    font-size: 48px !important; 
    font-family: emoji;
    color: white;
	margin-top: 3%;
    text-align: center;
	}
	.play_icon {
		text-align: center;
		color: #c5bcbc;
		font-size: 51px !important;
	}
	.intro_skips,.Recap_skip {
    position: absolute;
    margin-top: -10%;
    margin-bottom: 0;
   	/* z-index: -1; */
    margin-right: 0;
}
    .plyr--video {
    height: calc(100vh - 80px - 75px);
    max-width: none;
         width: 100%;}
    #videoPlayer{
      
    }
input.skips,input#Recaps_Skip{
  background-color: #21252952;
    color: white;
    padding: 15px 32px;
    text-align: center;
    margin: 4px 2px;
}
#intro_skip{
	display: none;
}
#Auto_skip{
	display: none;
}
	</style>

<!-- INTRO SKIP  -->

<?php
    $Auto_skip = App\HomeSetting::first();
    $Intro_skip = App\Episode::where('id',$episode->id)->first();
    $start_time = $Intro_skip->intro_start_time;
    $end_time = $Intro_skip->intro_end_time;
	$SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();

    $StartParse = date_parse($start_time);
    $startSec = $StartParse['hour']  * 60 *  60  + $StartParse['minute']  * 60  + $StartParse['second'];

    $EndParse = date_parse($end_time);
    $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];

	$SkipIntroParse = date_parse($Intro_skip['skip_intro']);
    $skipIntroTime =  $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];

// dd($SkipIntroPermission);
?>

<script>

  var SkipIntroPermissions = <?php echo json_encode($SkipIntroPermission); ?>;
  var video = document.getElementById("videoPlayer");
  var button = document.getElementById("intro_skip");
  var Start = <?php echo json_encode($startSec); ?>;
  var End = <?php echo json_encode($EndSec); ?>;
  var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;
  var IntroskipEnd = <?php echo json_encode($skipIntroTime); ?>;
//   alert(SkipIntroPermissions);

  if( SkipIntroPermissions == 0 ){
  button.addEventListener("click", function(e) {
    video.currentTime = IntroskipEnd;
       $("#intro_skip").remove();  // Button Shows only one tym
    video.play();
  })
    if(AutoSkip != 1){
		// alert(AutoSkip);

          this.video.addEventListener('timeupdate', (e) => {
            document.getElementById("intro_skip").style.display = "none";
            document.getElementById("Auto_skip").style.display = "none";
            var RemoveSkipbutton = End + 1;

            if (Start <= e.target.currentTime && e.target.currentTime < End) {
                    document.getElementById("intro_skip").style.display = "block"; // Manual skip
            } 
            if(RemoveSkipbutton  <= e.target.currentTime){
                  $("#intro_skip").remove();   // Button Shows only one tym
            }
        });
    }
    else{
      this.video.addEventListener('timeupdate', (e) => {
            document.getElementById("Auto_skip").style.display = "none";
            document.getElementById("intro_skip").style.display = "none";

            var before_Start = Start - 5;
            var trigger = Start - 1;

            if (before_Start <= e.target.currentTime && e.target.currentTime < Start) {
                document.getElementById("Auto_skip").style.display = "block";
                  if(trigger  <= e.target.currentTime){
                    document.getElementById("intro_skip").click();    // Auto skip
                  }
            }
        });
    }
}
</script>

<!-- Recap video skip -->

<?php
    $Recap_skip = App\Episode::where('id',$episode->id)->first();

    $RecapStart_time = $Recap_skip->recap_start_time;
    $RecapEnd_time = $Recap_skip->recap_end_time;

	$SkipRecapParse = date_parse($Recap_skip['skip_recap']);
    $skipRecapTime =  $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];

    $RecapStartParse = date_parse($RecapStart_time);
    $RecapstartSec = $RecapStartParse['hour']  * 60 *  60  + $RecapStartParse['minute']  * 60  + $RecapStartParse['second'];

    $RecapEndParse = date_parse($RecapEnd_time);
    $RecapEndSec = $RecapEndParse['hour'] * 60 * 60 + $RecapEndParse['minute'] * 60 + $RecapEndParse['second'];
?>

<script>
  var videoId = document.getElementById("videoPlayer");
  var button = document.getElementById("Recaps_Skip");
  var RecapStart = <?php echo json_encode($RecapstartSec); ?>;
  var RecapEnd = <?php echo json_encode($RecapEndSec); ?>;
  var RecapskipEnd = <?php echo json_encode($skipRecapTime); ?>;
  var RecapValue  = $("#Recaps_Skip").val();

  button.addEventListener("click", function(e) {
    videoId.currentTime = RecapskipEnd;
    $("#Recaps_Skip").remove();   // Button Shows only one tym
    videoId.play();
  })
      this.videoId.addEventListener('timeupdate', (e) => {
        document.getElementById("Recaps_Skip").style.display = "none";

        var RemoveRecapsbutton = RecapEnd + 1;
              if (RecapStart <= e.target.currentTime && e.target.currentTime < RecapEnd) {
                  document.getElementById("Recaps_Skip").style.display = "block"; 
              }
               
              if(RemoveRecapsbutton  <= e.target.currentTime){
                  $("#Recaps_Skip").remove();   // Button Shows only one tym
              }
    });
</script>


	
<script src="<?= URL::to('/'). '/assets/js/ls.bgset.min.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/lazysizes.min.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
 <script src="<?= URL::to('/'). '/assets/js/hls.min.js';?>"></script>
 <!-- <script src="<? //URL::to('/'). '/assets/js/plyr-3-7.js';?>"></script> -->
 <script src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>
<script>

  const player = new Plyr('#videoPlayer'); 

  var trailer_video_type =  <?php echo json_encode($episode->type) ; ?> ;
  

  if(trailer_video_type == "file" || trailer_video_type == "upload"){
    (function () {
      var video = document.querySelector('#videoPlayer');

      if (Hls.isSupported()) {
          var hls = new Hls();
          hls.loadSource(trailer_video_m3u8);
          hls.attachMedia(video);
          hls.on(Hls.Events.MANIFEST_PARSED,function() {
        });
      }
      
    })();

  }else if(trailer_video_type == "m3u8"){
  // alert(trailer_video_type);
  document.addEventListener("DOMContentLoaded", () => {
  const videos = document.querySelector('#video');
  // alert(video);
  const sources = videos.getElementsByTagName("source")[0].src;
  // alert(sources);
  const defaultOptions = {};

  if (Hls.isSupported()) {
    const hlstwo = new Hls();
    hlstwo.loadSource(sources);
    hlstwo.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      const availableQualities = hlstwo.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(videos, defaultOptions);
    });
    hlstwo.attachMedia(videos);
    window.hlstwo = hlstwo;
  }

  function updateQuality(newQuality) {
    window.hlstwo.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hlstwo.currentLevel = levelIndex;
      }
    });
  }
});

  }

</script>

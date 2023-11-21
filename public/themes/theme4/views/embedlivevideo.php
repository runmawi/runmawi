<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<link rel="stylesheet" href="<?= style_sheet_link();?>" />
<style>
  #videotitle{
    position: absolute;
    z-index: +1;
    color: white;
    top: 6%;
    left: 2%;
  }
  #videofavicon{
    position: absolute;
    z-index: +1;
    color: white;
    top: 10%;
    left: 2%;
  }
</style>

<?php
$str = $video->mp4_url;
if(!empty($str)){
$uri_parts = explode('.', $video->mp4_url);
$request_url = end($uri_parts);
}else{
  $request_url = '';
}


$rtmp_url = $video->rtmp_url;

$Rtmp_url = str_replace ('rtmp', 'http', $rtmp_url);

?>
        <?php if(!empty($video->mp4_url && $request_url != "m3u8"  && $video->url_type == "mp4" )): ?>
            <div id="series_container" class="fitvid">
                <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
                <video id="videoPlayer" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?=$video->mp4_url; ?>"  type="application/x-mpegURL" data-authenticated="<?=!Auth::guest() ?>">
                <source src="<?= $video->mp4_url; ?>" type='application/x-mpegURL' label='Auto' res='auto' />
                <source src="<?php echo $video->mp4_url; ?>" type='application/x-mpegURL' label='480p' res='480'/>
            </video>            
          </div>
        <?php  elseif(!empty($video->embed_url)  && $video->url_type == "embed"): ?>
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
                <iframe
                src="<?php if(!empty($video->embed_url)){ echo $video->embed_url	; }else { } ?>"
                allowfullscreen
                allowtransparency
                allow="autoplay">
            </iframe>
            </div>
        <?php  elseif(!empty($request_url == "m3u8")  && $video->url_type == "mp4"): ?>
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
                <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->mp4_url ?>">
                <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
                <input type="hidden" id="live" name="live" value="live">
                <input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url ?>">

                <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                    <source  type="application/x-mpegURL"  src="<?php echo $video->mp4_url; ?>" >
                </video>
            </div>
            <?php  elseif(!empty($video->url_type == "Encode_video")): ?>
            <div id="series_container">
            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->hls_url ; ?>">
            <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
            <input type="hidden" id="live" name="live" value="live">
            <input type="hidden" id="request_url" name="request_url" value="<?php echo "m3u8" ?>">
            <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
            <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
            <source  type="application/x-mpegURL"  src="<?php echo $video->hls_url ; ?>" >
        </video>
            </div>

            <?php  elseif(!empty($video->url_type ) && $video->url_type == "live_stream_video"): ?>
            <div id="series_container">
            <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
        <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
        <input type="hidden" id="live" name="live" value="live">
        <input type="hidden" id="request_url" name="request_url" value="<?php echo "m3u8" ?>">
        <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
        <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
        <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                    <source  type="application/x-mpegURL"  src="<?php echo $video->hls_url ; ?>" >
                </video>
            </div>
        <?php  else: ?>                                  
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/live/'. $video->slug; ?>" target="_blank"><?php echo $video->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <video id="videoPlayer"  controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
            </video>
            </div>
        <?php endif; ?>


        <script src="ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
 <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
          

 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
 <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
      <script src="ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <script>
    var type = '<?= $video->type ?>';
    var request_url = '<?= $request_url ?>';
    var url_type = '<?= $video->url_type ?>';

    // alert(type);
    // alert(request_url);

    // var episode_type  = $('#episode_type').val();

   if(request_url == "mp4" && request_url != 'm3u8'){
    alert(request_url);

        const player = new Plyr('#videoPlayer',{
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
    i18n:{
    // your other i18n
    capture: 'capture'
}

        });
   }else if(request_url == 'm3u8'){

    var mp4_url = '<?= $video->mp4_url ?>';

document.addEventListener("DOMContentLoaded", () => {
const video = document.querySelector("video");
const source = mp4_url;

// For more options see: https://github.com/sampotts/plyr/#options
// captions.update is required for captions to work with hls.js
const defaultOptions = {};

if (Hls.isSupported()) {
// For more Hls.js options, see https://github.com/dailymotion/hls.js
const hls = new Hls();
hls.loadSource(source);

// From the m3u8 playlist, hls parses the manifest and returns
// all available video qualities. This is important, in this approach,
// we will have one source on the Plyr player.
hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

  // Transform available levels into an array of integers (height values).
  const availableQualities = hls.levels.map((l) => l.height)

  // Add new qualities to option
  defaultOptions.quality = {
    default: availableQualities[0],
    options: availableQualities,
    // this ensures Plyr to use Hls to update quality level
    forced: true,        
    onChange: (e) => updateQuality(e),
  }

  // Initialize here
  const player = new Plyr(video, defaultOptions);
});
hls.attachMedia(video);
window.hls = hls;
}

function updateQuality(newQuality) {
window.hls.levels.forEach((level, levelIndex) => {
  if (level.height === newQuality) {
    console.log("Found quality match with " + newQuality);
    window.hls.currentLevel = levelIndex;
  }
});
}
});

   }else if(url_type == 'Encode_video'){

var hls_url = '<?= $video->hls_url ?>';

document.addEventListener("DOMContentLoaded", () => {
const video = document.querySelector("video");
const source = hls_url;

// For more options see: https://github.com/sampotts/plyr/#options
// captions.update is required for captions to work with hls.js
const defaultOptions = {};

if (Hls.isSupported()) {
// For more Hls.js options, see https://github.com/dailymotion/hls.js
const hls = new Hls();
hls.loadSource(source);

// From the m3u8 playlist, hls parses the manifest and returns
// all available video qualities. This is important, in this approach,
// we will have one source on the Plyr player.
hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

// Transform available levels into an array of integers (height values).
const availableQualities = hls.levels.map((l) => l.height)

// Add new qualities to option
defaultOptions.quality = {
default: availableQualities[0],
options: availableQualities,
// this ensures Plyr to use Hls to update quality level
forced: true,        
onChange: (e) => updateQuality(e),
}

// Initialize here
const player = new Plyr(video, defaultOptions);
});
hls.attachMedia(video);
window.hls = hls;
}

function updateQuality(newQuality) {
window.hls.levels.forEach((level, levelIndex) => {
if (level.height === newQuality) {
console.log("Found quality match with " + newQuality);
window.hls.currentLevel = levelIndex;
}
});
}
});

}
    else if(url_type == 'live_stream_video'){

    var live_stream_video = '<?= $video->live_stream_video ?>';

    document.addEventListener("DOMContentLoaded", () => {
  const video = document.querySelector("video");
  const source = live_stream_video;
  
  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const defaultOptions = {};

  if (Hls.isSupported()) {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);

    // From the m3u8 playlist, hls parses the manifest and returns
    // all available video qualities. This is important, in this approach,
    // we will have one source on the Plyr player.
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      // Transform available levels into an array of integers (height values).
      const availableQualities = hls.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(video, defaultOptions);
    });
    hls.attachMedia(video);
    window.hls = hls;
  }

  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});
    

   }else{
    document.addEventListener("DOMContentLoaded", () => {

    var live_stream_video = '<?= $video->live_stream_video ?>';

  const video = document.querySelector("video");
  const source = live_stream_video;
  
  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const defaultOptions = {};

  if (Hls.isSupported()) {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);

    // From the m3u8 playlist, hls parses the manifest and returns
    // all available video qualities. This is important, in this approach,
    // we will have one source on the Plyr player.
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      // Transform available levels into an array of integers (height values).
      const availableQualities = hls.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(video, defaultOptions);
    });
    hls.attachMedia(video);
    window.hls = hls;
  }

  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});
    

   }
      </script>



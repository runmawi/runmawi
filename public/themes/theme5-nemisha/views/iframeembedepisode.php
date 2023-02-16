<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />
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
        <?php if($episode->type == 'embed'): ?>
            <div id="series_container" class="fitvid">
                <span id="videotitle"><a href="<?= URL::to('/'). '/episode/'.$series->title.'/'. $episode->slug; ?>" target="_blank"><?php echo $episode->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <?= $episode->embed_code ?>
            </div>
        <?php  elseif($episode->type == 'file' || $episode->type == 'upload'): ?>
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/episode/'. $series->title.'/'.$episode->slug; ?>" target="_blank"><?php echo $episode->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <video id="videoPlayer"  class="video-js vjs-default-skin" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' width="100%" style="width:100%;" type="video/mp4"  data-authenticated="<?= !Auth::guest() ?>">
            <source src="<?= $episode->mp4_url; ?>" type='video/mp4' label='auto' >
            </video>
            </div>
        <?php  elseif($episode->type == 'm3u8'): ?>
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/episode/'.$series->title.'/'. $episode->slug; ?>" target="_blank"><?php echo $episode->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <video id="video"  controls crossorigin playsinline 
            poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" 
            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
            <source 
                type="application/x-mpegURL" 
                src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '.m3u8'; ?>"
            >
            </video>
            </div>
        <?php  else: ?>                                  
            <div id="series_container">
                <span id="videotitle"><a href="<?= URL::to('/'). '/episode/'. $series->title.'/'.$episode->slug; ?>" target="_blank"><?php echo $episode->title ?></a></span>
                <span id="videofavicon"><image src="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" /></span>
            <video id="videoPlayer"  controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
            </video>
            </div>
        <?php endif; ?>


        

        <script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
 <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
          

 <script src="plyr-plugin-capture.js"></script>
 <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
 <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
 <script>
    var type = '<?= $episode->type ?>';

   if(type == "file" || type == "upload"){
        const player = new Plyr('#videoPlayer',{
          controls: [

      'play-large',
			'restart',
			'rewind',
			'play',
			'fast-forward',
			'progress',
			'current-time',
			// 'mute',
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
   }
else if(type == "m3u8"){
          document.addEventListener("DOMContentLoaded", () => {
  const video = document.querySelector("video");
  const source = video.getElementsByTagName("source")[0].src;
  
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
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
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

<div class="video_playlist_content">
<?php
$ads_details = App\AdsVideo::join(
    "advertisements",
    "advertisements.id",
    "ads_videos.ads_id"
)
    ->where("ads_videos.video_id", $first_videos->id)
    ->pluck("ads_path")
    ->first();

$default_ads_url = App\Setting::pluck("default_ads_url")->first();
$default_ads_status = App\Video::where("id", $first_videos->id)
    ->pluck("default_ads")
    ->first();

if ($default_ads_url != null && $default_ads_status == 1) {
    $default_ads = $default_ads_url;
} else {
    $default_ads = null;
}

if ($ads_details != null) {
    $ads_path = $ads_details;
} else {
    $ads_path = $default_ads;
}


$autoplay =  "autoplay" ;
?>

<?php
$str = $first_videos->m3u8_url;
if (!empty($str)) {
    $request_url = "m3u8";
    // dd($first_videos->m3u8);
}
if (!empty($request_url)) { ?>
<input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url; ?>">
<?php }
?>

<input type="hidden" name="ads_path" id="ads_path" value="<?php echo $ads_path; ?>">

<input type="hidden" name="video_id" id="video_id" value="<?php echo $first_videos->id; ?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo $playerui_settings->watermark_logo; ?>">
<input type="hidden" name="video_title" id="video_title" value="<?php echo $first_videos->title; ?>">

  <input type="hidden" name="current_time" id="current_time" value="<?php if (
      isset($watched_time)
  ) {
      echo $watched_time;
  } else {
      echo "0";
  } ?>">
  <input type="hidden" id="videoslug" value="<?php if (isset($first_videos->slug)) {
      echo $first_videos->slug;
  } else {
      echo "0";
  } ?>">
  <input type="hidden" id="base_url" value="<?php echo URL::to("/"); ?>">
  <input type="hidden" id="videotype" value="<?php echo $first_videos->type; ?>">
  <input type="hidden" id="videovideo" value="video">
  <input type="hidden" id="adsurl" value="<?php if (isset($ads->ads_id)) {
      echo get_adurl($ads->ads_id);
  } ?>">
<?php if ($first_videos->type == "embed"): ?>
           <div id="video_container" class="fitvid">
             <?php if (!empty($first_videos->embed_code)) { ?>
              <div class="plyr__video-embed" id="player">
            <iframe
              src="<?php if (!empty($first_videos->embed_code)) {
                  echo $first_videos->embed_code;
              } else {
                  echo $first_videos->trailer;
              } ?>"
              allowfullscreen
              allowtransparency
              allow="<?= $autoplay ?>"
            ></iframe>
          </div>
             <?php } ?>
           </div>
           <?php elseif ($first_videos->type == ""): ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">


          <video  <?= $autoplay ?> id="video_playlist_player"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to(
    "/"
) .
    "/public/uploads/images/" .
    $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo URL::to("/storage/app/public/") .
              "/" .
              $first_videos->path .
              ".m3u8"; ?>"  type='application/x-mpegURL' label='auto' > 
  <?php if (@$playerui_settings["subtitle"] == 1) {
      if (isset($subtitles)) {
          foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
      }
  } ?>
</video>

  <input type="hidden" id="hlsm3u8" name="hls_m3u8" value="<?php echo URL::to(
      "/storage/app/public/"
  ) .
      "/" .
      $first_videos->path .
      ".m3u8"; ?>">

</div>
  
           <?php elseif ($first_videos->type == "aws_m3u8"): ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">

          <video  <?= $autoplay ?> id="video"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to(
    "/"
) .
    "/public/uploads/images/" .
    $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo $first_videos->m3u8_url; ?>"  type='application/x-mpegURL' label='auto' > 
          <?php if (@$playerui_settings["subtitle"] == 1) {
              if (isset($subtitles)) {
                  foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
              }
          } ?>
        </video>
        </div>
           <?php elseif ($first_videos->type == "mp4_url"): ?>
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <video id="videoPlayer"  class="adstime_url" poster="<?= URL::to(
                   "/"
               ) .
                   "/public/uploads/images/" .
                   $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                   <source src="<?php if (!empty($first_videos->mp4_url)) {
                       echo $first_videos->mp4_url;
                   } else {
                       echo $first_videos->trailer;
                   } ?>"  type='video/mp4' label='auto' > 
                
                   <?php if (@$playerui_settings["subtitle"] == 1) {
                       if (isset($subtitles)) {
                           foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                       }
                   } ?>
               </video>
 
            
           </div>
           <?php elseif ($first_videos->type == "m3u8_url"): ?>
        
        <video  <?= $autoplay ?> id="video" <?= $autoplay ?> class="adstime_url" poster="<?= URL::to(
     "/"
 ) .
     "/public/uploads/images/" .
     $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                <source src="<?php if (!empty($first_videos->m3u8_url)) {
                    echo $first_videos->m3u8_url;
                } else {
                    echo $first_videos->trailer;
                } ?>"  type='application/x-mpegURL' label='auto' > 
                <?php if (@$playerui_settings["subtitle"] == 1) {
                    if (isset($subtitles)) {
                        foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                    }
                } ?>
            </video>
   <?php else: ?>
               <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <video  id="videoPlayer" class="adstime_url" poster="<?= URL::to(
                   "/"
               ) .
                   "/public/uploads/images/" .
                   $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                   <source src="<?php if (!empty($first_videos->m3u8_url)) {
                       echo $first_videos->m3u8_url;
                   } else {
                       echo $first_videos->trailer;
                   } ?>"  type='application/x-mpegURL' label='auto' > 
                   <?php if (@$playerui_settings["subtitle"] == 1) {
                       if (isset($subtitles)) {
                           foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                       }
                   } ?>
               </video>
 
            
           </div>
   <?php endif; ?>
   </div>
   <link rel="stylesheet" href="https://unpkg.com/plyr@3/dist/plyr.css">
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL"></script>
<script src="https://unpkg.com/plyr@3"></script>
<script  src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
 <script  src="<?= URL::to('/'). '/assets/js/hls.min.js';?>"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/0.14.5/hls.min.js.map"></script>
 <script  src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>
<script>
    var type = $('#videotype').val();
    var request_url = $('#request_url').val();
    var video_video = $('#videovideo').val();
    var hls = $('#hls').val();

                   
    if (type != "" && type != "m3u8_url" && video_video == 'video' && type != 'aws_m3u8') {

        const player = new Plyr('#videoPlayer', {
            controls: ['play-large',
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
            i18n: {
                capture: 'capture'
            },

            ads: {
                enabled: true,
                publisherId: '',
                tagUrl: video_tag_url
            }
        });

    }

    // Normal MP4 URL Script
    // else if (type == ""){
        else{
            alert('type');

        // document.addEventListener("DOMContentLoaded", () => {
            const video_playlist_player = document.querySelector("#video_playlist_player");
            const source = video_playlist_player.getElementsByTagName("source")[0].src;
                alert(source);
            const defaultOptions = {};

            if (!Hls.isSupported()) {

                defaultOptions.ads = {
                    enabled: true,
                    tagUrl: video_tag_url
                }

                video_playlist_player.src = source;
                var player = new Plyr(video_playlist_player, defaultOptions);
            } else {
                const hls = new Hls();
                hls.loadSource(source);

                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    defaultOptions.quality = {
                        default: 0, //Default - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                        var span = document.querySelector(
                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })
                    var player = new Plyr(video_playlist_player, defaultOptions);

                });

                hls.attachMedia(video_playlist_player);
                window.hls = hls;
            }


            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                } else {
                    window.hls.levels.forEach((level, levelIndex) => {
                        if (level.height === newQuality) {
                            console.log("Found quality match with " + newQuality);
                            window.hls.currentLevel = levelIndex;
                        }
                    });
                }
            }
        // });


    }

</script>
 
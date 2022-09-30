<?php //dd($video); ?>
<head>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
</head>
@if($video->type == 'embed')
    <div id="video_container" class="fitvid">
        @if($video->type == 'embed')
            <div class="plyr__video-embed" id="player">
                <iframe
                    src="@if(!empty($video->embed_code)){{  $video->embed_code }} else {{  $video->trailer }} @endif"
                    allowfullscreen
                    allowtransparency
                    allow="autoplay">
                </iframe>
            </div>
        @endif
    </div>


@elseif($video->type == '')

    <div id="video_container" class="fitvid" style="z-index: 9999;">
        <video id="video" style="width: 100%;height: 600;" class="adstime_url" controls crossorigin playsinline poster="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
            <source 
                type="application/x-mpegURL" 
                src="{{ URL::to('/storage/app/public/').'/'.@$video->path . '.m3u8' }}"
            >
        </video>
    </div>

@elseif($video->type == 'mp4_url')

    <div id="video_container" class="fitvid" >
        <video id="videoPlayer" style="width: 100%;height: 600;"class="adstime_url" poster="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                   <source src="@if(!empty($video->mp4_url)){{  $video->mp4_url }} @endif"  type='video/mp4' label='auto' > 
        </video>
    </div>

@elseif($video->type == 'm3u8_url')

    <video style="width: 100%;height: 600;" id="M3U8_video-videos" class=""  poster=""
        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' type="application/x-mpegURL">
        <source  type="application/x-mpegURL"  src="{{ $video->m3u8_url }}">
    </video>

@endif




<input type="hidden" value="@if(!empty($video)){{ @$video->type }} @endif" id = "video_type">
<!-- Trailer m3u8 -->
<!-- && !empty($next_start) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>

<script>


  var video_type =  $('#video_type').val();
//   alert(video_type);

  if(video_type != ''){

    const player = new Plyr('#videoPlayer'); 
 
  }else if(video_type == ""){
//   alert(video_type);
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

  }else if( video_type == "m3u8_url"){

const video = document.querySelector('#M3U8_video-videos');
const source = trailer_url ;
const defaultOptions = {};

if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(source);

        hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
        const availableQualities = hls.levels.map((l) => l.height)

        defaultOptions.quality = {
            default: availableQualities[0],
            options: availableQualities,
            forced: true,        
            onChange: (e) => updateQuality(e),
        }

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
}
</script>


<head>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
</head>
<style>
    body{
        background: linear-gradient(180deg, #040404 0%, #3D3D47 100%);
    }
    .plyr__progress{ pointer-events: none; }
    #novideo{
        color: #fff;
        text-align: center;
        display: flex;
        align-content: center;
        align-self: center;
        justify-content: center;
    }
    #novideo h2{
        margin-top: 20%;
    }
</style>
@if(!empty($ScheduleVideos) && !empty($new_date)  && empty($Choose_current_date))
    @if($ScheduleVideos->type == 'mp4_url')
        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                <!-- Current time: <div id="current_time"></div> -->
            <video id="videoPlayer" autoplay="true" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >               
                <source src="<?php if(!empty($ScheduleVideos->mp4_url)){   echo $ScheduleVideos->mp4_url; } ?>"  type='video/mp4' label='auto' >      
            </video>
        </div>
    @elseif ($ScheduleVideos->type == '')
            <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                <video id="video" autoplay controls crossorigin controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                    <source  type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/').'/'.$ScheduleVideos->path . '.m3u8'; ?>">
                </video>
        </div>
    @endif

@elseif(empty($ScheduleVideos) && empty($Choose_current_date))

      <div id="novideo">
            <h2> COMING SOON </h2>
            <p class="countdown" id="demo"></p>
      </div>
@elseif(!empty($Choose_current_date))
        <div id="novideo">
            <h2> NO Video Available For Today </h2>
            <p class="countdown" id="demo"></p>
        </div>

@endif


<input type="hidden" value="@if(!empty($ScheduleVideos)){{ @$ScheduleVideos->type }} @endif" id = "video_type">
<!-- Trailer m3u8 -->
<!-- && !empty($next_start) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>

      function goBack() {
          window.location.hash = window.location.lasthash[window.location.lasthash.length-1];
          //blah blah blah
          window.location.lasthash.pop();
      }
  </script>
<script>
// Set the date we're counting down to
var date = "<?= $next_start ?>";
var new_date = "<?= $new_date ?>";

if(date != ''){
    var countDownDate = new Date(date).getTime();
    // alert(countDownDate)
    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
    // alert(now)
        
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    // alert(distance)
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
        
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        // document.getElementById("demo").innerHTML = "EXPIRED";
    location.reload();
    }
    }, 1000);
}else if(new_date != ''){
    var 
    var countDownDate = new Date(new_date).getTime();
    // alert(new_date)
    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
    // alert(now)
        
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    // alert(distance)
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // alert(hours);
    // Output the result in an element with id="demo"
    // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    // + minutes + "m " + seconds + "s ";
        
    // If the count down is over, write some text 
    // alert(distance);
    if (distance < 0) {
        clearInterval(x);
        // document.getElementById("demo").innerHTML = "EXPIRED";
    location.reload();
    }
    }, 1000);

}
</script>


<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>


  var video_type =  <?php echo json_encode( @$ScheduleVideos->type); ?>; 

  // alert(video_type);

  if(video_type != ''){

    const player = new Plyr('#videoPlayer'); 
 
  }else if(video_type == "" || empty(video_type)){
  // alert(video_type);
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

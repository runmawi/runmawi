@php
    include public_path('themes/default/views/header.php');
@endphp
    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="//vjs.zencdn.net/7.15.4/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@2.0.6/dist/videojs-contrib-quality-levels.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/6.6.5/videojs.ads.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.min.js"></script>


    <div class="col-md-12 container">
        <video id="my-video" class="video-js vjs-theme-fantasy" controls preload="auto" width="640" height="360"  >
            <source src="https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8" type="application/x-mpegURL">
        </video>
    </div>

<script>

  document.addEventListener("DOMContentLoaded", function () {

    var player = videojs('my-video', {
        aspectRatio: '16:9',
        playbackRates: [0.5,1,1.5,2,3,4]
    });

    player.httpSourceSelector();

    var vastTagPreroll ="https://v.adserve.tv/pg/vast.xml";
    var vastTagMidroll ="https://v.adserve.tv/rama/vast.xml";
    var vastTagPostroll ="https://v.adserve.tv/pg/vast.xml";
    
    var prerollTriggered = false;
    var postrollTriggered = false;
    var midrollRequested = false;
    var midrollInterval = 30; // 5 minutes
    var lastMidrollTime = 0; // The time when the last mid-roll ad was played

    if (!prerollTriggered) {
      player.ima({
        adTagUrl: vastTagPreroll,
        showControlsForAds: true,
        debug: false,
      });
    } else {
      player.ima({
        adTagUrl: '',
        showControlsForAds: true,
        debug: false,
      });
    }

    console.log("IMA settings configured");

    player.ima.initializeAdDisplayContainer();
    console.log("IMA ad display container initialized");

    function requestMidrollAd() {
      midrollRequested = true;
      player.ima.changeAdTag(vastTagMidroll);
      player.ima.requestAds();
    }

    player.on("timeupdate", function () {
      var currentTime = player.currentTime();
      console.log("Current time:", currentTime);
      var timeSinceLastMidroll = currentTime - lastMidrollTime;

      if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {
        lastMidrollTime = currentTime; // Update the last mid-roll ad time
        console.log("Midroll triggered");
        requestMidrollAd();
      }
    });

    player.on("ended", function () {
      console.log("Video ended");
      if (!postrollTriggered) {
        postrollTriggered = true;
        console.log("Postroll triggered");

        player.ima.requestAds({
          adTagUrl: vastTagPostroll,
        });

        console.log("Postroll ads requested");
      }
    });

    player.on("adsready", function () {
      if (midrollRequested) {
        console.log("Ads ready - midroll");
      } else {
        console.log("Ads ready - preroll");
        player.src(
          "https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8"
        );
      }
    });

    player.on("aderror", function () {
      console.log("Ads aderror");
      player.play();
    });

    player.on("adend", function () {
      if (lastMidrollTime > 0) {
        console.log("A midroll ad has finished playing.");
        midrollRequested = false;
      } else {
        console.log("The preroll ad has finished playing.");
        prerollTriggered = true;
      }

      player.play();
    });
  });
</script>


@php include public_path('themes/default/views/footer.blade.php'); @endphp
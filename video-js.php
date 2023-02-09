<html>
<head>
  <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet">
  <link href="https://unpkg.com/silvermine-videojs-quality-selector@1.1.2/dist/css/quality-selector.css" rel="stylesheet">
  <link rel="stylesheet" href="//googleads.github.io/videojs-ima/node_modules/videojs-contrib-ads/dist/videojs.ads.css" />
  <link rel="stylesheet" href="//googleads.github.io/videojs-ima/dist/videojs.ima.css" />

  <script src="https://unpkg.com/video.js@7/dist/video.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-quality-levels/2.0.9/videojs-contrib-quality-levels.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.1/dist/videojs-hls-quality-selector.min.js"></script>
</head>

<body>
<video id="videojs"  class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered vjs-playback-rate"  controls autoplay muted live  >
    <source src="https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8" type="application/x-mpegURL">
</video>



  <!-- Load dependent scripts -->
    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="//googleads.github.io/videojs-ima/node_modules/videojs-contrib-ads/dist/videojs.ads.min.js"></script>
    <script src="//googleads.github.io/videojs-ima/dist/videojs.ima.js"></script>

<script type="text/javascript">

    var player = videojs('videojs', {
      playbackRates: [0.5, 1, 1.5, 2],
      liveui: true
    });
    
    player.hlsQualitySelector();

        var options = {
          id: 'videojs',
          adTagUrl: 'http://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=xml_vmap1&unviewed_position_start=1&cust_params=sample_ar%3Dpremidpostpod%26deployment%3Dgmf-js&cmsid=496&vid=short_onecue&correlator='
        };

    player.ima(options);
    
        
</script>

</body>
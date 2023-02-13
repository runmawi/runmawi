

<html>
    <head>

      <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
       <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
      <script type="text/javascript" src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
      <script type="text/javascript" src="https://cdn.plyr.io/3.7.2/plyr.polyfilled.js"></script>
      <script type="text/javascript" src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
    </head>


    
    <body>
        <video id="live_player" controls crossorigin playsinline title autoplay >
          <source type="application/x-mpegURL" src="http://localhost/flicknexs/public/uploads/LiveStream/1676228945vi2-livestream-video.m3u8" >
        </video>

        <input type="button" value="Refresh Button" onClick="window.location.reload()"> 

        <button id="trigger" onclick="msg()">Auto Click</button>


        <script>

    var  counnt = localStorage.getItem('count');
    var  storage = localStorage.setItem('count',0);
    count = parseInt(storage)

    if(counnt == 0 ){
      var  storage = localStorage.setItem('count',parseInt(counnt)+1);
      location.reload(true);

      document.getElementById("trigger").click();

      function msg(){
        window.location.reload();
      }

    }

        document.addEventListener("DOMContentLoaded", () => {

          var video = document.querySelector('#live_player');
          const source = video.getElementsByTagName("source")[0].src;
          
          const defaultOptions = {};
        
          if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(source);
        
           
            hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
        
              const availableQualities = hls.levels.map((l) => l.height)
              defaultOptions.quality = {
                default: 0, //Default - AUTO
                options: availableQualities,
                forced: true,    
                onChange: (e) => updateQuality(e),
              }
              
              defaultOptions.ads = {
                enabled: true,
                tagUrl: 'https://pubads.g.doubleclick.net/gampad/ads?iu=/21775744923/external/vmap_ad_samples&sz=640x480&cust_params=sample_ar%3Dpremidpostpod&ciu_szs=300x250&gdfp_req=1&ad_rule=1&output=vmap&unviewed_position_start=1&env=vp&impl=s&cmsid=496&vid=short_onecue&correlator='
              }
              
              const player = new Plyr(video, defaultOptions);
            });
            hls.attachMedia(video);
            window.hls = hls;
          } else {
              defaultOptions.ads = {
                enabled: true,
                tagUrl: 'https://pubads.g.doubleclick.net/gampad/ads?iu=/21775744923/external/vmap_ad_samples&sz=640x480&cust_params=sample_ar%3Dpremidpostpod&ciu_szs=300x250&gdfp_req=1&ad_rule=1&output=vmap&unviewed_position_start=1&env=vp&impl=s&cmsid=496&vid=short_onecue&correlator='
              }
            
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
        </script>
    </body>
</html>
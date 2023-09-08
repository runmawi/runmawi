<script>

    let video_url = "<?php echo $videodetail->videos_url ?>" ; 

    document.addEventListener("DOMContentLoaded", function () {

        var player = videojs('my-video', {
            aspectRatio: '16:9',
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true, 
        });

            // hls Quality Selector - M3U8 
    
        player.hlsQualitySelector({
            displayCurrentQuality: true,
        });    

        var vastTagPreroll = null ;
        var vastTagMidroll = null ;
        var vastTagPostroll = null ;
    
        var prerollTriggered = false;
        var postrollTriggered = false;
    
        var midrollRequested = false;
        var midrollInterval = 5 * 60; 
        var lastMidrollTime = 0;        
    
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
    
        player.ima.initializeAdDisplayContainer();
    
        function requestMidrollAd() {
            midrollRequested = true;
            player.ima.changeAdTag(vastTagMidroll);
            player.ima.requestAds();
        }
    
        player.on("timeupdate", function () {
            var currentTime = player.currentTime();
            // console.log("Current time:", currentTime);
            var timeSinceLastMidroll = currentTime - lastMidrollTime;
    
            if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {
                lastMidrollTime = currentTime;
                // console.log("Midroll triggered");
                requestMidrollAd();
            }
        });
    
        player.on("ended", function () {
        //   console.log("Video ended");
            if (!postrollTriggered) {
                postrollTriggered = true;
                // console.log("Postroll triggered");
    
                player.ima.requestAds({
                    adTagUrl: vastTagPostroll,
                });
                // console.log("Postroll ads requested");
            }
        });
    
        player.on("adsready", function () {
            if (midrollRequested) {
              // console.log("Ads ready - midroll");
            } else {
              // console.log("Ads ready - preroll");
                player.src(video_url);
            }
        });
    
        player.on("aderror", function () {
          console.log("Ads aderror");
          player.play();
        });
    
        player.on("adend", function () {
            if (lastMidrollTime > 0) {
            //   console.log("A midroll ad has finished playing.");
                midrollRequested = false;
            } else {
            //   console.log("The preroll ad has finished playing.");
                prerollTriggered = true;
            }
            player.play();
        });
    });
    </script>
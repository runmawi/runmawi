<script>

    let video_url = "<?php echo $videodetail->videos_url ?>" ; 

    document.addEventListener("DOMContentLoaded", function () {

        var player = videojs('my-video', {              // Video Js Player 
            aspectRatio: '16:9',
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true, 

            controlBar: {
                
                volumePanel: {
                    inline: false
                },

                children: {
                    'playToggle':{},
                    'currentTimeDisplay':{},
                    'timeDivider':{},
                    'durationDisplay':{},
                    'liveDisplay':{},

                    'flexibleWidthSpacer':{},
                    'progressControl':{},

                    'settingsMenuButton': {
                        entries : [
                            'subtitlesButton',
                            'playbackRateMenuButton'
                        ]
                    },
                    'fullscreenToggle':{}
                }
		    }
        });


                    // Back Button 
        const Back_button = videojs.dom.createEl('button', {
            className: '', 
            innerHTML: '<i class="fa fa-arrow-left" aria-hidden="true"></i>', 
            title: 'Back Button', 
        });
      
        player.controlBar.el().appendChild(Back_button);
        
        Back_button.addEventListener('click', function () {
            history.back();
        });

    
        player.hlsQualitySelector({                     // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });    
                                                        
        var vastTagPreroll  =  '<?= $pre_advertisement ?>' ;  // Advertisement
        var vastTagPostroll =  '<?= $post_advertisement ?>' ;

        var prerollTriggered = false;
        var postrollTriggered = false;

        const vastTagMidroll_array = '<?php echo $mid_advertisement ?>' ;
        const vastTagMidrollArray = vastTagMidroll_array != "" ? JSON.parse(vastTagMidroll_array) : null ;
    
        var midrollRequested = false;
        var midrollInterval = '<?= $video_js_mid_advertisement_sequence_time ?>' ; 
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
    
        function requestMidrollAd  ( vastTagMidroll ) {

            midrollRequested = true;

            player.ima.changeAdTag(vastTagMidroll);

            player.ima.requestAds();
        }
    
        player.on("timeupdate", function () {

            var currentTime = player.currentTime();

            var timeSinceLastMidroll = currentTime - lastMidrollTime;
    
            if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {

                lastMidrollTime = currentTime;
                // console.log("Midroll triggered");
                
                const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);

                const vastTagMidroll = vastTagMidrollArray[random_array_index];

                requestMidrollAd(vastTagMidroll);
            }
        });
    
        player.on("ended", function () {

            if (!postrollTriggered) {

                postrollTriggered = true;

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
<script>

    let video_url = "<?php echo $videodetail->videos_url ?>" ; 
    var video_viewcount_limit = "<?php echo $video_viewcount_limit; ?>";
    var user_role = "<?php echo $user_role; ?>";
    var played_views = "<?php echo $videodetail->played_views; ?>";

    document.addEventListener("DOMContentLoaded", function() {
        var player = videojs('my-video', { // Video Js Player 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            controlBar: {
                volumePanel: { inline: false },
                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'subtitlesButton': {},
                    'playbackRateMenuButton': {},
                    'fullscreenToggle': {},      
                    // 'audioTrackButton': {}               
                },
                pictureInPictureToggle: true,
            }
        });

        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');
        const titleButton = document.querySelector('.vjs-title-bar');

        player.el().appendChild(skipForwardButton);
        player.el().appendChild(skipBackwardButton);
        player.el().appendChild(titleButton);
        player.el().appendChild(backButton);

        skipForwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() + 10);
        });

        skipBackwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() - 10);
        });

        player.on('userinactive', () => {
            skipForwardButton.addEventListener('mouseenter',handleHover);
            skipBackwardButton.addEventListener('mouseenter',handleHover);

            skipForwardButton.addEventListener('mouseleave',handleHover);
            skipBackwardButton.addEventListener('mouseleave',handleHover);

            function handleHover(event) {
                const element = event.target;
                if (event.type === 'mouseenter') {
                    // console.log("hovered");
                    hovered = true;
                } else if (event.type === 'mouseleave') {
                    // console.log("not hovered");
                    hovered = false;
                }
            }

            // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(hovered == false){
                    skipForwardButton.style.display = 'none';
                    skipBackwardButton.style.display = 'none';
                    playPauseButton.style.display = 'none';
                }
                backButton.style.display = 'none';
            }
        });

        player.on('useractive', () => {
            // Show the Play pause, skip forward and backward buttons when the user becomes active
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                skipForwardButton.style.display = 'block';
                skipBackwardButton.style.display = 'block';
                playPauseButton.style.display = 'block';
                backButton.style.display = 'block';
            }
        });

            
        let viewCountSent = false;

        function PartnerMonetization(videoId, currentTime) {
            currentTime = Math.floor(currentTime);
            // console.log(currentTime);

            var countview;

            if ((user_role === 'registered' || user_role === 'subscriber' || user_role === 'guest' ) && !viewCountSent && currentTime > video_viewcount_limit) {
                viewCountSent = true;
                countview = 1;
              
                $.ajax({
                    url: "<?php echo URL::to('PartnerMonetization');?>",
                    type: 'POST',
                    data: {
                        _token: '<?= csrf_token() ?>',
                        video_id: videoId,
                        currentTime: currentTime,
                        countview: countview,
                    },
                });
            }

            // console.log('currentTime: ' + currentTime);
            // console.log('countview: ' + countview);
        }


        if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
            player.on('timeupdate', function() {
                var currentTime = player.currentTime();
                PartnerMonetization(videoId, currentTime);
            });

            player.on('pause', function() {
                var currentTime = player.currentTime();
                PartnerMonetization(videoId, currentTime);
            });
        }

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                var currentTime = player.currentTime();
                PartnerMonetization(videoId, currentTime);
            }
        });

                    // Back Button 
        // const Back_button = videojs.dom.createEl('button', {
        //     className: '', 
        //     innerHTML: '<i class="fa fa-arrow-left" aria-hidden="true"></i>', 
        //     title: 'Back Button', 
        // });
      
        // player.controlBar.el().appendChild(Back_button);
        
        // Back_button.addEventListener('click', function () {
        //     history.back();
        // });

    
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

        // player.endcard({
        //     getRelatedContent: getRelatedContent,
        //     // getNextVid: getNextVid, 
        //     count: 20
        // });

    });
</script>